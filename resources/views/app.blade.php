@extends('master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @foreach($extensions as $thisKey => $extension)
                    <h3>{{ $extension['name'] }}</h3>
                    <div class="extension-tree">
                        <ul>
                            @foreach($extension['tags'] as $thisTag)
                                <li>
                                    {{ $thisTag }}
                                    <ul>
                                        @foreach($extension['locales'] as $thisLocale)
                                            <li>
                                                <a href="{{ url("/$thisKey/$thisTag/$thisLocale") }}">
                                                    {{ $thisLocale }}.yml
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="col-md-8">
                @if (isset($locale))
                    <a class="btn btn-secondary float-right" href="{{ url("/$key/$tag/$locale.yml") }}">
                        <i class="fas fa-download"></i>
                        Raw file
                    </a>
                    <h2>{{ $extensions[$key]['name'] }} / {{ $tag }} / {{ $locale }}.yml</h2>
                    <pre>{{ $file }}</pre>
                @else
                    <h2>Welcome to the KILOWHAT premium extension translations project</h2>
                    <p>This page allows you to access the translation files of my premium extensions even if you don't
                        have an active license. The data is synced from the source code automatically and new tags
                        should appear within 30 minutes of an update.</p>
                    <p>It follows the requests from language pack maintainers to access this information.</p>
                    <p>The information available on this service is given as-it, without any guarantee. You may
                        translate and publish them as long as you make it clear the translation is not official.</p>
                    <p>For premium extension purchasers: only the languages listed on the official documentation page
                        are bundled and maintained. Unofficial translations might not cover all features. If you have
                        an issue with a third-party language pack, please contact the authors of the language pack.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
