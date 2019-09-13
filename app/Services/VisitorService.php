<?php

namespace App\Services;

use App\Repositories\VisitorRepository;
use Log;

class VisitorService
{

    private $repository;

    public function __construct(VisitorRepository $repository)
    {
        $this->repository = $repository;
    }


    public function get($visitor)
    {
        return $this->repository->get($visitor);
    }

    public function getByToken($visitor_token)
    {
        return $this->repository->getByToken($visitor_token);
    }

    public function create($visitor)
    {
        
        $v = $this->repository->create($visitor);
        Log::channel('actions')->info('New Vistor', ["visitor"=>$v->getKey()]);
        return $v;
    }

    public function verify($visitor_id, $code)
    {
        return $this->repository->verify($visitor_id, $code);
    }

}
