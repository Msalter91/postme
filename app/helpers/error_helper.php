<?php

declare(strict_types=1);

function myException($exception) :void {
    flash($exception->getMessage());
    redirect('pages/index/error');
}
set_exception_handler('myException');
