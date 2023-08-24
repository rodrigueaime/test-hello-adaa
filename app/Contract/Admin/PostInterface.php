<?php

namespace App\Contract\Admin;

interface PostInterface
{
    public function all();

    public function show($recepteur);

    public function store(array $parms);

    public function update(array $parms, $recepteur);

    public function destroy($recepteur);
}
