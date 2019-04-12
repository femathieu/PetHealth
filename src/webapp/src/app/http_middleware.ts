import { Observable } from 'rxjs/';
import {Injectable} from '@angular/core';
import {HttpEvent, HttpInterceptor, HttpHandler, HttpRequest} from '@angular/common/http';

@Injectable()
export class HttpMiddleware implements HttpInterceptor {

    constructor(){
    }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        if(localStorage.getItem('token') != null){
            /// must clone because req is immutable
            const clonedRequest = req.clone({ headers: req.headers.set('Authorization', localStorage.getItem('token')) });
            return next.handle(clonedRequest);
        }else{
            return next.handle(req);
        }
    }

}