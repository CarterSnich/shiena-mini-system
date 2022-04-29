<?php

function redirectToPage(String $page)
{
    header("location: $page");
    exit();
}
