import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpResponse} from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of } from 'rxjs';

import { User } from '../../models/user';
import { UserService } from '../user/user.service';
import { AppConfig } from '../../config';
import { MatSnackBar } from '@angular/material';
import { JwtHelperService } from '@auth0/angular-jwt';


@Injectable({
  providedIn: 'root'
})
export class LoginService {
  private baseUrlApi: string = 'http://localhost';
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };
  public user: User;
  private config: AppConfig = new AppConfig();
  public jwtHelper: JwtHelperService = new JwtHelperService();

  constructor(
    private client: HttpClient,
    private userService: UserService,
    private snackBar: MatSnackBar,
  ) {
    this.user = new User();
  }

  login(user: User): Observable<any> {
    return this.client.post(`${this.config.getApiBaseUrl}/login`, user, {headers: this.httpOptions.headers, observe: 'response'})
      .pipe(
        tap((response: any) => {
          console.log('login');
          if(response instanceof HttpResponse){
            if(response.status == 200){
              localStorage.setItem('token', response.body.token);
              this.user = response.body.user;
            }else{
              console.log(response.body.msg)
            }
          }
        }),
        catchError(this.handleError<User>('login', new User()))
      );
    }
    
  register(): Observable<any> {
    return this.client.post(`${this.config.getApiBaseUrl}/user`, this.user, {headers: this.httpOptions.headers, observe: 'response'},)
      .pipe(
        tap(_ => {console.log('register')}),
        catchError(this.handleError<User>('add user'))
      );
  }

  public isAuthenticated(): boolean {
    var ret: boolean = false;
    const token = localStorage.getItem('token');
    if(token != null){
      if(!this.jwtHelper.isTokenExpired(token)){
        ret = true;
      }else{
        console.error('token expired');
      }
    }else{
      console.error('no token');
    }
    return ret;
  }

  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
 
      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead
 
      // TODO: better job of transforming error for user consumption
      console.log(`${operation} failed: ${error.message}`);
 
      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }
}
