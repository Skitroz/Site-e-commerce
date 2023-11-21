<?php
class SignOutController
{
    public function signOut()
    {
        session_destroy();
        header("Location: /Site-e-commerce");
        exit();
    }
}
?>
