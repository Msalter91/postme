<?php

function myException(): void
{
   flash('post_message', 'Something has gone wrong.', 'alert alert-danger');
   redirect('pages/index/error');
}
set_exception_handler('myException');
