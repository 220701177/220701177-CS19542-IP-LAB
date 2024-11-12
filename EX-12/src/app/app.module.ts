import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { AboutComponent } from './about/about.component';
import { BlogComponent } from './blog/blog.component';

const routes: Routes = [
    { path: '', component: HomeComponent },
    { path: 'about', component: AboutComponent },
    { path: 'blog', component: BlogComponent },
    { path: '**', redirectTo: '' } 
];

@NgModule({
declarations: [
    AppComponent,
    HomeComponent,
    AboutComponent,
    BlogComponent
],
imports: [
    BrowserModule,
    RouterModule.forRoot(routes)
],
providers: [],
bootstrap: [AppComponent]
})
export class AppModule { }
