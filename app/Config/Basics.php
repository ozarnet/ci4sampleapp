<?php

//  Open-Source License Information:
/*
The MIT License (MIT)

Copyright (c) 2019-2021 Agung Sugiarto (https://agungsugiarto.github.io)

Copyright (c) 2020-2021 Gökhan Ozar (https://www.ozar.net/)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Basics extends BaseConfig {

	public $appName = 'CountriesCitiesPeopleDB';

	public $i18n = 'English'; 

	public $languages = [
		'en' => 'English',
	];


	public $languageFlags = [
		'en' => 'us',
	];


	public $authImplemented = false;




	public $theme = [
		'name' => 'Bootstrap5',
		'body-sm' => false,
		'navbar'  => [
		'bg'     => 'gray',
		'type'   => 'dark',
		'border' => true,
		'user'   => [
		'visible' => true,
		'shadow'  => 0,
		],
	],
		'sidebar' => [
		'type'    => 'dark',
		'shadow'  => 4,
		'border'  => false,
		'compact' => true,
		'links'   => [
		'bg'     => 'black', // only works with AdminLTE theme
		'shadow' => 1,
	],
		'brand' => [
		'bg'   => 'gray-dark',
		'logo' => [
		'icon'   => 'favicon.ico', // path to image | this example icon on public root folder.
		'text'   => 'CountriesCitiesPeopleDB',
		'shadow' => 2,
		],
	],
		'user' => [
		'visible' => true,
		'shadow'  => 2,
		],
	],
		'footer' => [
		'fixed'      => false,
        'organization' => 'Ozar',
        'orglink' => 'https://www.ozar.net',
		],
	];

}
