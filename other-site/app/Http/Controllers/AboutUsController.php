<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PartnersService;
use App\Services\TeamsService;
use App\Services\OurServicesService;
use App\Services\PortfoliosService;

class AboutUsController extends Controller
{
	private $partnersService,$teamsService;

	public function __construct(PartnersService $partnersService, TeamsService $teamsService, OurServicesService $ourServicesService, PortfoliosService $portfoliosService){
		$this->partnersService = $partnersService;
		$this->teamsService = $teamsService;
        $this->ourServicesService = $ourServicesService;
        $this->portfoliosService = $portfoliosService;
	}

    public function index()
    {
    	$clients = $this->partnersService->getPartners();
    	$teams = $this->teamsService->getTeams();
        $our_services = $this->ourServicesService->getServices();
        $portfolios = $this->portfoliosService->getPortfolios();
        return view('front-ends.about-us.index',compact('clients','teams','our_services','portfolios'));
    }
}
