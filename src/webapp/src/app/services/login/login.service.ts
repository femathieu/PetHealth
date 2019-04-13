import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of } from 'rxjs';

import { User } from '../../models/user';
import { UserService } from '../user/user.service';
import { AppConfig } from '../../config';
import { MatSnackBar } from '@angular/material';
import { RegisterComponent } from 'src/app/register/register.component';

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

  constructor(
    private client: HttpClient,
    private userService: UserService,
    private snackBar: MatSnackBar
  ) {
    this.user = new User();
  }

  login(user: User) {
    this.client.post(`${this.config.getApiBaseUrl}/login`, user, this.httpOptions)
      .pipe(
        tap(_ => {console.log('login')}),
        catchError(this.handleError<User>('login', new User()))
      ).subscribe((response: any) => {
        if(response.result){
          localStorage.setItem('token', response.token);
          this.user = this.userService.getUserByEmail(user.email);
        }else{
          console.log(response.msg)
        }
      });
    }
    
  register(): Observable<any> {
    return this.client.post(`${this.config.getApiBaseUrl}/user`, this.user, {headers: this.httpOptions.headers, observe: 'response'},)
      .pipe(
        tap(_ => {console.log('register')}),
        catchError(this.handleError<User>('add user'))
      );
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
