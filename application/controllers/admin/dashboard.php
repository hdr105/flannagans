<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function index() {
        $this->load->model('crud_auth');
        $this->load->model('admin/admin_menu');

        $var = array();
        
        $var['main_menu'] = $this->admin_menu->fetch();
        $var['main_content'] = $this->load->view('admin/common/dashboard',$var,true);
        
        $this->load->model('admin/admin_footer');
        $var['main_footer'] = $this->admin_footer->fetch();

        $this->load->template('layouts/admin/dashboard', $var);
        // note more needed, becuase we loaded via templtea nd My_Loader
        //$this->load->view('layouts/admin/dashboard', $var);
    }
    public function openjobs(){   
        $this->load->view('admin/common/widgets/openjobs',$var);
    }
    public function deadlines(){   
        $this->load->view('admin/common/widgets/deadlines',$var);
    }
    public function staffholiday(){   
        $this->load->view('admin/common/widgets/staffholiday',$var);
    }
    public function dueclientfee(){   
        $this->load->view('admin/common/widgets/dueclientfee',$var);
    }
    public function staffonbreak(){   
        $this->load->view('admin/common/widgets/staffonbreak',$var);
    }
    public function jobassignedtoeachstaff(){   
        $this->load->view('admin/common/widgets/jobassignedtoeachstaff',$var);
    }
    public function staffworkinghours(){   
        $this->load->view('admin/common/widgets/staffworkinghours',$var);
    }
    public function available_holidays(){   
        $this->load->view('admin/common/widgets/available_holidays',$var);
    }
    //CLIENT Dashboard
    public function openServices(){   
        $this->load->view('admin/common/widgets/openServices',$var);
    }
    public function openDates(){   
        $this->load->view('admin/common/widgets/openDates',$var);
    }
    public function openTax(){   
        $this->load->view('admin/common/widgets/openTax',$var);
    }

}