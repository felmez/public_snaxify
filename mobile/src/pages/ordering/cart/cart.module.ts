import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { CartPage } from './cart';
import { TranslateModule } from '@ngx-translate/core';
import { PipesModule } from '../../../pipes/pipes.module';

@NgModule({
  declarations: [
    CartPage
  ],
  imports: [
    IonicPageModule.forChild(CartPage),
    PipesModule,
    TranslateModule.forChild()
  ]
})
export class CartPageModule {
}
