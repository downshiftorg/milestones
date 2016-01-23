<?php

namespace netrivet\milestones;

class Repository
{
    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $name;

    /**
     * Repository constructor.
     * @param string $user
     * @param string $name
     */
    public function __construct($user, $name)
    {
        $this->user = $user;
        $this->name = $name;
    }
}
