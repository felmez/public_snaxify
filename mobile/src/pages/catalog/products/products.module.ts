import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { ProductsPage } from './products';
import { TranslateModule } from '@ngx-translate/core';
import { PipesModule } from '../../../pipes/pipes.module';
import { ComponentsModule } from '../../../components/components.module';

@NgModule({
  declarations: [
    ProductsPage
  ],
  imports: [
    ComponentsModule,
    PipesModule,
    IonicPageModule.forChild(ProductsPage),
    TranslateModule.forChild()
  ]
})
export class ProductsPageModule {
}
