import { BrowserModule } from '@angular/platform-browser';
import { NgModule, LOCALE_ID } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MainModule } from './views/main/main.module';
import { HttpClientModule } from '@angular/common/http';
import { LoginModule } from './views/login/login.module';
import { registerLocaleData } from '@angular/common';
import localePt from '@angular/common/locales/pt';

registerLocaleData(localePt, 'pt-BR');

@NgModule({
  declarations: [
    AppComponent,
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    LoginModule,
    MainModule
  ],
  bootstrap: [
    AppComponent
  ],
  providers: [
    {provide: LOCALE_ID, useValue: 'pt-BR'}
  ]
})
export class AppModule { }
