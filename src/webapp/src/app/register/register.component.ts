import { Component, OnInit } from '@angular/core';
import { LoginService } from '../services/login/login.service';
import { User } from '../models/user';
import { HttpResponse } from '@angular/common/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  constructor(
    public loginService: LoginService,
    private router: Router
  ) { }

  ngOnInit() {
  }

  save(): void {
    if(this.validEmail()){
      if(this.validPassword()){
        this.loginService.register().subscribe((response: HttpResponse<any>) => {
            if(response.status == 200){
              this.router.navigate(['/login']);
            }
        });
      }else{
        console.log('invalid passwd');
      }
    }else{
      console.log('invalid email');
    }
  }

  validEmail(): boolean {
    var ret: boolean = false
    const regexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    ret = regexp.test(this.loginService.user.email);
    return ret;
  }

  validPassword(): boolean {
    var ret: boolean = false;
    if(this.loginService.user.passwd == this.loginService.user.passwdv){
      ret = true;
    }
    return ret;
  }
}
