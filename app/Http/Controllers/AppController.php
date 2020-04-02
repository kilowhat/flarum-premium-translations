<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Arr;

class AppController extends Controller
{
    protected $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function homepage()
    {
        return view('app')
            ->with('extensions', $this->extensions());
    }

    public function translations(string $key, string $tag, string $locale)
    {
        $extension = $this->validateExtension($key, $tag, $locale);

        return view('app')
            ->with('extensions', $this->extensions())
            ->with('key', $key)
            ->with('tag', $tag)
            ->with('locale', $locale)
            ->with('file', $this->file(Arr::get($extension, 'repo'), $tag, $locale));
    }

    public function raw(string $key, string $tag, string $locale)
    {
        $extension = $this->validateExtension($key, $tag, $locale);

        return response($this->file(Arr::get($extension, 'repo'), $tag, $locale), 200, [
            'Content-Type' => 'text/plain',
        ]);
    }

    protected function validateExtension(string $key, string $tag, string $locale): array
    {
        $extension = Arr::get(config('extensions.repos'), $key);

        if (!$extension) {
            abort(404);
        }

        if (!in_array($tag, $this->tags(Arr::get($extension, 'repo')))) {
            abort(404);
        }

        if (!in_array($locale, Arr::get($extension, 'locales'))) {
            abort(404);
        }

        return $extension;
    }

    protected function extensions(): array
    {
        return array_map(function (array $extension): array {
            return $extension + [
                    'tags' => $this->tags(Arr::get($extension, 'repo')),
                ];
        }, config('extensions.repos'));
    }

    protected function client(): Client
    {
        return new Client([
            'base_uri' => 'https://api.github.com/repos/',
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'Authorization' => 'token ' . config('extensions.github_token'),
            ],
        ]);
    }

    protected function tags(string $repo): array
    {
        return $this->cache->remember($repo . '-tags', 1800, function () use ($repo): array {
            $response = $this->client()->get($repo . '/git/refs/tags');

            return array_reverse(array_map(function (array $ref): string {
                return Arr::last(explode('/', Arr::get($ref, 'ref')));
            }, \GuzzleHttp\json_decode($response->getBody()->getContents(), true)));
        });
    }

    protected function file(string $repo, string $tag, string $locale): string
    {
        return $this->cache->remember($repo . '-' . $tag . '-' . $locale . '-file', 1800, function () use ($repo, $tag, $locale): string {
            $response = $this->client()->get($repo . '/contents/resources/locale/' . $locale . '.yml', [
                'query' => [
                    'ref' => $tag,
                ],
            ]);

            return base64_decode(Arr::get(\GuzzleHttp\json_decode($response->getBody()->getContents(), true), 'content'));
        });
    }
}
