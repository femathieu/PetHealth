import { Injectable } from '@angular/core';
import { User } from './models/user';
import { HttpClient } from '@angular/common/http';
import { AppConfig } from './config';
import { Observable, of } from 'rxjs';
import { tap, catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  private config: AppConfig = new AppConfig();

  constructor(
    private client: HttpClient,
  ) { }

  public getUserByEmail(userEmail: string): User{
    console.log('UserService->getUserByEmail');
    var user: User = new User();
    this.client.get(`${this.config.getApiBaseUrl}/user/${userEmail}`)
      .pipe(
        tap(_ => {console.log('login')}),
        catchError(this.handleError<User>('login', new User()))
      ).subscribe((response: any) => {
        console.log('user : ', response);
        user = response;
      });
    return user;
  }

  private handleError<T>(operation = 'operation', result?: T){
    return (error: any): Observable<T> => {
      console.error(error);
      console.log(`Operation : ${operation} failed : ${error.message}`);
      return of(result as T);
    }
  }
}
