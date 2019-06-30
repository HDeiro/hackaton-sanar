import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatSidenavModule, MatToolbarModule, MatListModule, MatIconModule, MatMenuModule, MatButtonModule } from '@angular/material';
import { EnsureModule } from 'src/app/pipes/ensure/ensure.module';
import { MainComponent } from './main.component';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

@NgModule({
  declarations: [
    MainComponent
  ],
  imports: [
    BrowserAnimationsModule,
    FormsModule,
    MatSidenavModule,
    MatToolbarModule,
    MatButtonModule,
    MatIconModule,
    MatMenuModule,
    CommonModule,
    EnsureModule,
    RouterModule,
    MatListModule
  ],
  exports: [
    MainComponent
  ]
})
export class MainModule { }
