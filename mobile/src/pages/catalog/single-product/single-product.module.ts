import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { TranslateModule } from '@ngx-translate/core';
import { PipesModule } from '../../../pipes/pipes.module';
import { SingleProductPage } from './single-product';
import { ComponentsModule } from '../../../components/components.module';

@NgModule({
  declarations: [
    SingleProductPage
  ],
  imports: [
    ComponentsModule,
    PipesModule,
    IonicPageModule.forChild(SingleProductPage),
    TranslateModule.forChild()
  ]
})
export class SingleProductPageModule {
}
