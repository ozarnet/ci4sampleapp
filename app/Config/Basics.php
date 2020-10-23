<?php

//  Open-Source License Information:
/*
    The MIT License (MIT)

    Copyright (c) 2019-2020 Agung Sugiarto (https://agungsugiarto.github.io)
    Copyright (c) 2014-2020 ColorlibHQ (https://adminlte.io)
    Copyright (c) 2020 Gökhan Ozar (https://gokhan.ozar.net/)

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

	public $appName = 'Country City Person DB';

	public $i18n = 'English'; 

	public $authImplemented = false;

//--------------------------------------------------------------------------
// Theme options
//
// BG: blue, indigo, purple, pink, red, orange, yellow, green, teal, cyan,
//     gray, gray-dark, black
// Type: dark, light
// Shadow: 0-4
//
//--------------------------------------------------------------------------

	public $theme = [
		'name' => 'AdminLTE3',
		'body-sm' => false,
		'navbar'  => [
		'bg'     => 'white',
		'type'   => 'light',
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
		'bg'     => 'blue',
		'shadow' => 1,
	],
		'brand' => [
		'bg'   => 'gray-dark',
		'logo' => [
		'icon'   => 'favicon.ico', // path to image | this example icon on public root folder.
		'text'   => 'CountryCityPersonDB',
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
		'organization' => 'Ozar.net',
		'orglink' => 'https://www.ozar.net/?ref=gh',
		],
	];

}
