<?php

declare(strict_types=1);

class FormKey
{
    public function __construct()
    {
        if (isset($_SESSION['form_key'])) {
            $this->old_formKey = $_SESSION['form_key'];
        }
    }

    private string $formKey;

    private string $old_formKey;

    private function generateKey(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $uniqid = uniqid('', true);
        return md5($ip . $uniqid);
    }

    public function outputKey(): void
    {
        $this->formKey = $this->generateKey();
        $_SESSION['form_key'] = $this->formKey;
        echo "<input type='hidden' name='form_key' id='form_key' value='"  . $this->formKey . "' />";
    }

    public function validate(): bool
    {
        if ($_POST['form_key'] == $this->old_formKey) {
            return true;
        } else {
            return false;
        }
    }

}
