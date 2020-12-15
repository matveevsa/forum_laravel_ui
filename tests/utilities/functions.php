<?php

function create($class, $attrs = [], $times = null)
{
    return $class::factory()->count($times)->create($attrs);
}

function make($class, $attrs = [], $times = null)
{
    return $class::factory()->count($times)->make($attrs);
}
