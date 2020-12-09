<?php

function create($class, $attrs = [])
{
    return $class::factory()->create($attrs);
}

function make($class, $attrs = [])
{
    return $class::factory()->make($attrs);
}
