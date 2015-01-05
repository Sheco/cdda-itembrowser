<?php
class BaseController extends Controller {
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        $this->layout = View::make("layouts.bootstrap");
    }
}
