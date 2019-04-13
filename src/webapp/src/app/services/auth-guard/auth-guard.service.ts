import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router/src/utils/preactivation';
import { LoginService } from '../login/login.service';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthGuardService implements CanActivate {
  path: import("@angular/router").ActivatedRouteSnapshot[];
  route: import("@angular/router").ActivatedRouteSnapshot;

  constructor(
    public loginService: LoginService,
    public router: Router
  ) { }

  canActivate(): boolean {
    if(!this.loginService.isAuthenticated()){
      this.router.navigate(['/login']);
      return false;
    }
    return true;
  }
}
