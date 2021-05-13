<?php

class Triggers {
  
    /**
     * 
     * @var (\Closure|callable)[][]
     */
    protected $triggers = [];
    
    /**
     * 
     * @param \TriggersHandler
     */
    public function addHandler(\TriggersHandler $handler) {
        foreach (\get_class_methods($handler) as $method) {
            if (\substr($method, 0, 2) === "__") { // magic methods
                continue;
            }
            $this->add($method, [$handler, $method]);
        }
    }
    
    /**
     * 
     * @param scalar $id
     * @param \Closure|callable $trigger
     */
    public function add($id, $trigger) {
        $this->triggers[$id][] = $trigger;
    }
    
    /**
     * 
     * @param scalar $id
     */
    public function remove($id) {
        unset($this->triggers[$id]);
    }
  
    /**
     *
     * @param scalar $id
     * @return (\Closure|callable)[][]|(\Closure|callable)[]|null
     */
    public function get($id = null) {
        if ($id !== null) {
            return $this->triggers[$id] ?? null;
        }
        return $this->triggers;
    }
    
    /**
     * 
     * @param scalar $id
     * @param mixed[] $args
     * @return bool
     */
    public function handle($id, array $args = []) {
        if (isset($this->triggers["onHandle"])) {
            foreach ($this->triggers["onHandle"] as $trigger) {
                if (\is_callable($trigger))($trigger)($id, $args);
            }
        }
        
        if (!isset($this->triggers[$id])) {
            return false;
        }
        
        foreach ($this->triggers[$id] as $trigger) {
            if (\is_callable($trigger)) {
                \call_user_func_array($trigger, $args);
            }
        }
        return true;
    }
}
