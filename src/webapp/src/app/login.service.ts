import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';
import { catchError, map, tap } from 'rxjs/operators';
import { Observable, of } from 'rxjs';

import { User } from './models/user';

@Injectable({
  providedIn: 'root'
})
export class LoginService {
  private baseUrlApi: string = 'http://localhost';
  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor(
    private client: HttpClient,
  ) {

  }

  login(user: User) : Observable<any>{
    return this.client.post(`${this.baseUrlApi}/user/login`, user, this.httpOptions)
      .pipe(
        tap(_ => {console.log('login')}),
        catchError(this.handleError<User>('login', new User()))
      )
  }

  private handleError<T>(operation = 'operation', result?: T){
    return (error: any): Observable<T> => {
      console.error(error);
      console.log(`Operation : ${operation} failed : ${error.message}`);
      return of(result as T);
    }
  }
}
