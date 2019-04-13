import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PetComponent } from './pet/pet.component';
import { MainComponent as PetMain } from './main/main.component' ;
import { HealthBookComponent } from './health-book/health-book.component';
import { ProfilComponent as PetProfil } from './profil/profil.component';
import { CrudComponent } from './crud/crud.component';
import { AuthGuardService as AuthGuard } from '../services/auth-guard/auth-guard.service';

const petRoutes: Routes = [
  { path: 'pet', component: PetComponent,
    children: [
      { path: 'main', component: PetMain, data: { state: 'main' }},
      { path: 'healthbook', component: HealthBookComponent, data: { state: 'healthbook' } },
      { path: 'profil', component: PetProfil, data: { state: 'profil'} },
      { path: 'crud', component: CrudComponent },
    ],
    canActivate: [AuthGuard]
  },
];

@NgModule({
  imports: [RouterModule.forChild(petRoutes)],
  exports: [RouterModule]
})
export class PetRoutingModule { }
