import { Component, OnInit } from '@angular/core';

import { LoginService } from '../services/login/login.service';

import { User } from '../models/user';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})

export class LoginComponent implements OnInit {
  user: User = new User();

  constructor(private loginService: LoginService) { }

  ngOnInit() {
  }

  login(): void {
    console.log("LoginComponent->login()");
    this.loginService.login(this.user);
  }
}
