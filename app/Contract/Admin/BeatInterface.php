<?php

namespace App\Contract\Admin;

interface BeatInterface
{
    public function all();

    public function show($recepteur);

    public function store(array $parms);

    public function update(array $parms, $recepteur);

    public function destroy($recepteur);
}
