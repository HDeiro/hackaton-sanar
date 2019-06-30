import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { PrescriptionComponent } from './prescription/prescription.component';

const routes: Routes = [
  { 
    path: '',
    component: PrescriptionComponent,
    data: {
      pageName: 'Prescription',
      pageTitle: 'Health Tracker > Prescription'
    }
  }
]

@NgModule({
  imports: [ RouterModule.forChild(routes) ],
  exports: [ RouterModule ]
})
export class PrescriptionRoutingModule { }
