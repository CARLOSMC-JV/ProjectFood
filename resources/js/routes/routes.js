// routes.js
import ProductDetails from '../Pages/ProductDetail/Index.vue';

const routes = [
  {
    path: '/product/:id',
    name: 'product.details',
    component: ProductDetails,
    props: true,
  },
  // Otras rutas...
];

export default routes;
