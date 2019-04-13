import { Component, OnInit, Inject } from '@angular/core';

import { LoginService } from '../services/login/login.service';

import { User } from '../models/user';
import { MAT_SNACK_BAR_DATA, MatSnackBar } from '@angular/material';
import { HttpResponse } from '@angular/common/http';
import { timer } from 'rxjs';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})

export class LoginComponent implements OnInit {
  user: User = new User();

  constructor(
    private loginService: LoginService,
    private snackBar: MatSnackBar,
    private router: Router
  ) { }

  ngOnInit() {
  }

  login(): void {
    console.log("LoginComponent->login()");
    this.loginService.login(this.user).subscribe((response: any) => {
      if(response instanceof HttpResponse){
        if(response.status == 200){
          this.snackBar.open('Authentification réussie', '', {duration: 1500})
          let time = timer(1800, 1800).subscribe(_ => {
            this.router.navigate(['/pet/main']);
            time.unsubscribe();
          });
        }else{
          this.snackBar.open('L\'authentification a échoué', '', {duration: 1500})
        }
      }else{
        this.snackBar.open('L\'authentification a échoué', '', {duration: 1500})
      }
    });
  }
}
