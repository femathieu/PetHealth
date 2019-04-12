import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule }    from '@angular/forms';

import { MainComponent as PetMain} from './main/main.component';
import { ProfilComponent as PetProfil} from './profil/profil.component';
import { HealthBookComponent } from './health-book/health-book.component';

import { PetRoutingModule } from './pet-routing.module';
import { PetComponent } from './pet/pet.component';
import { CrudComponent } from './crud/crud.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatTabsModule } from '@angular/material/tabs';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatSelectModule } from '@angular/material/select';
import { MatStepperModule } from '@angular/material/stepper';
import { MatInputModule } from '@angular/material/input';
import { MatRadioModule } from '@angular/material/radio';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material/core';
import { MatCardModule } from '@angular/material/card';
import { HeaderComponent } from '../header/header.component';

@NgModule({
  declarations: [
    PetComponent,
    PetMain,
    PetProfil,
    HealthBookComponent,
    CrudComponent,
    HeaderComponent,

  ],
  imports: [
    CommonModule,
    FormsModule,
    PetRoutingModule,
    BrowserAnimationsModule,
    MatTabsModule,
    MatFormFieldModule,
    MatSelectModule,
    MatStepperModule,
    MatInputModule,
    MatRadioModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatCardModule,
    ReactiveFormsModule
  ],
  providers: [
    MatDatepickerModule,
  ]
})

export class PetModule { }
