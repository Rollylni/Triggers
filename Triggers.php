<?php

class Triggers {
  
    /**
     * 
     * @var (\Closure|callable)[][]
     */
    protected $triggers = [];
    
    /**
     * 
     * @param scalar $id
     * @param \Closure|callable $trigger
     */
    public function addTrigger($id, $trigger) {
        $this->triggers[$id][] = $trigger;
    }
    
    /**
     * 
     * @param scalar $id
     */
    public function removeTriggers($id) {
        unset($this->triggers[$id]);
    }
    
    /**
     * 
     * @param scalar $id
     * @param mixed[] $args
     * @return bool
     */
    public function handleTriggers($id, array $args = []) {
        if (!isset($this->triggers[$id])) {
            return false;
        }
        
        foreach ($this->triggers[$id] as $trigger) {
            if (($trigger instanceof \Closure) && \is_callable($trigger)) {
                \call_user_func_array($trigger, $args);
            }
        }
        return true;
    }
}
