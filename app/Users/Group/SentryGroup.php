<?php namespace Users\Group;

 use Cartalyst\Sentry\Sentry;

class SentryGroup implements GroupInterface {

    protected $sentry;

    /**
     * Construct a new SentryGroup Object
     */
    public function __construct(Sentry $sentry) {
        $this->sentry = $sentry;
    }

    /**
     * Return a specific group by a given id
     * 
     * @param  integer $id
     * 
     * @return mixed
     */
    public function byId($id) {
        try {
            $group = $this->sentry->findGroupById($id);
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return false;
        }
        return $group;
    }

    /**
     * Return a specific group by a given name
     * 
     * @param  string $name
     * 
     * @return mixed
     */
    public function byName($name) {
        try {
            $group = $this->sentry->findGroupByName($name);
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            return false;
        }
        return $group;
    }

    /**
     * Return all the registered groups
     *
     * @return stdObject Collection of groups
     */
    public function all() 
    {
        return $this->sentry->getGroupProvider()->findAll();
    }

}
