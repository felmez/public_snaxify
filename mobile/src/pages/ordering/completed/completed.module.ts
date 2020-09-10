import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { CompletedPage } from './completed';
import { TranslateModule } from '@ngx-translate/core';

@NgModule({
  declarations: [
    CompletedPage
  ],
  imports: [
    IonicPageModule.forChild(CompletedPage),
    TranslateModule.forChild()
  ],
  providers: []
})
export class CompletedPageModule {
}
