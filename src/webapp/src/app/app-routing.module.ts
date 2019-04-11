import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';
import { RegisterComponent } from './register/register.component';
import { MainComponent as PetMain } from './pet/main/main.component' ;
import { HealthBookComponent } from './pet/health-book/health-book.component';
import { ProfilComponent as PetProfil } from './pet/profil/profil.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  { path: 'home', component: HomeComponent },
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes,)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
