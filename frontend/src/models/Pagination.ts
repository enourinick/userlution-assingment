interface Pagination<T> {
  current_page: number;
  last_page: number;
  total: number;
  from: number;
  per_page: number;
  to: number;
  data: T[];
}

export default Pagination;
