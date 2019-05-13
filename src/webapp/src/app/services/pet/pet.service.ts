import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders} from '@angular/common/http';

import { Pet } from '../../models/pet';
import { AppConfig } from '../../config';
import { tap, catchError } from 'rxjs/operators';
import { of, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PetService {

  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };
  private config: AppConfig = new AppConfig();

  constructor(
    private client: HttpClient,
  ) { }

  add(pet: Pet) : Observable<any> {
    return this.client.post(`${this.config.getApiBaseUrl}/pet`, pet, {headers: this.httpOptions.headers, observe: 'response'}).pipe(
      tap(_ => console.log('add pet')),
      catchError(this.handleError('add pet'))
    );
  }

  private handleError<T>(operation = 'operation', result?: T){
    return (error: any): Observable<T> => {
      console.error(error);
      console.log(`Operation : ${operation} failed : ${error.message}`);
      return of(result as T);
    }
  }
}
