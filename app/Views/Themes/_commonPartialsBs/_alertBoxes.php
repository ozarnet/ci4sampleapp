<?php

    //  Open-Source License Information:
    /*
        The MIT License (MIT)

        Copyright (c) 2020 Ozar (https://www.ozar.net/)

        Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
        to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
        and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

        The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
        THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
        INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. 
        IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
        WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

    */

    $errorMessage = $errorMessage ?? session('errorMessage');
    $warningMessage = session('warningMessage');

    if (session()->has('message')) {
        $successMessage = session('message');
    }
    if (session()->has('error')) {
        $errorMessage = is_array(session('error')) ? implode(session('error')) : session('error');
    } /* // Uncomment this block if you want the errors listed line by line in the alert
    elseif (session()->has('errors')) {
        $errorMessage = '<ul class="text-start">';
        foreach (session('errors') as $error) :
            $errorMessage .= '<li>' . $error . '</li>';
        endforeach;
        $errorMessage .= '</ul>';
    }
    */
?>

<?php if (isset($successMessage) && $successMessage): ?>

<div class="alert alert-success" role="alert">
    <svg class="bi mt-1 me-3 float-start" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
    <div>
        <h4><?=lang('Basic.global.Success')?>!</h4>
        <?= $successMessage; ?>
    </div>
    
</div>

<?php endif; ?>

<?php if (isset($errorMessage) && $errorMessage): ?>

<div class="alert alert-danger" role="alert">
    <svg class="bi mt-1 me-3 float-start" width="24" height="24" role="img" aria-label="Error:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
    <div>
        <h4><?=lang('Basic.global.Error')?>!</h4>
        <?= $errorMessage; ?>
    </div>
</div>

<?php endif; ?>

<?php if (isset($warningMessage) && $warningMessage): ?>

<div class="alert alert-warning" role="alert">
    <svg class="bi mt-1 me-3 float-start" width="24" height="24" role="img" aria-label="Error:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
    <div>
        <h4 class="text-start"><?=lang('Basic.global.Warning')?></h4>
        <?= $warningMessage ?>
    </div>
</div>

<?php endif; ?>