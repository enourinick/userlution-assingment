interface Category {
  name: string;
  has_age_restriction: boolean;
}

interface Product {
  id: number;
  name: string;
  category: Category;
  description: string;
  image_url: string;
  price: number;
}

export default Product;
