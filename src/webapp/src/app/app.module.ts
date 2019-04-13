import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { HttpMiddleware } from './http_middleware';
import { RegisterComponent } from './register/register.component';
import { HeaderComponent } from './header/header.component';
import { HeaderOverviewComponent } from './header-overview/header-overview.component';
import { HeaderLoginComponent } from './header-login/header-login.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatTabsModule} from '@angular/material/tabs';
import { PetModule } from './pet/pet.module';
import { MatSnackBarModule, MAT_SNACK_BAR_DATA, MatSnackBar } from '@angular/material';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    RegisterComponent,
    HeaderOverviewComponent,
    HeaderLoginComponent,
  ],
  imports: [
    BrowserModule,
    PetModule,
    AppRoutingModule,
    FormsModule,
    NgbModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatTabsModule,
    MatSnackBarModule
  ],
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: HttpMiddleware,
      multi: true,
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
