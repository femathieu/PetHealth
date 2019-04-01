import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of } from 'rxjs';

import { User } from '../../models/user';
import { UserService } from '../user/user.service';
import { AppConfig } from '../../config';

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
  ) {
    this.user = new User();
  }

  login(user: User) {
    this.client.post(`${this.config.getApiBaseUrl}/user/login`, user, this.httpOptions)
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

  private handleError<T>(operation = 'operation', result?: T){
    return (error: any): Observable<T> => {
      console.error(error);
      console.log(`Operation : ${operation} failed : ${error.message}`);
      return of(result as T);
    }
  }
}
