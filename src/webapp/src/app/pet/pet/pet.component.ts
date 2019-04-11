import { Component, OnInit } from '@angular/core';
import { Routes, RouterModule, Router, RouterOutlet } from '@angular/router';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { routerTransition } from '../animation-routing';

@Component({
  selector: 'app-pet',
  templateUrl: './pet.component.html',
  styleUrls: ['./pet.component.scss'],
  animations: [
    routerTransition
  ]
})

export class PetComponent implements OnInit {
  navLinks = [];
  constructor(private router: Router) { 
  }

  ngOnInit() {
  }

  getState(outlet: RouterOutlet) {
    return outlet.activatedRouteData.state;
  }
  
}
