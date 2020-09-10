import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { OrderPage } from './order';
import { TranslateModule } from '@ngx-translate/core';
import { Stripe } from '@ionic-native/stripe';
import { PayPal } from '@ionic-native/paypal';
import { PipesModule } from '../../../pipes/pipes.module';

@NgModule({
  declarations: [
    OrderPage
  ],
  imports: [
    IonicPageModule.forChild(OrderPage),
    PipesModule,
    TranslateModule.forChild()
  ],
  providers: [
    Stripe,
    PayPal
  ]
})
export class OrderPageModule {
}
