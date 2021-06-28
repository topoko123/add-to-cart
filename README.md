# Add to Cart

## จัดทำโดยใช้โครงสร้าง สถาปัตยกรรม MVC 

## Requirement
- ไม่ต้องมีใน่ส่วนของ View (M "V" C)                  /
- ทำระบบ Add to Cart (ระบบตะกร้าสินค้า)             /
- มี Model อย่างน้อยสอง Model เช่น Product , Users  /
- มีการใช้งาน Middleware                          X
- เลือกใช้งาน Database                            /
- PHP Laravel                                  /

ในส่วนที่ใช้เครื่องหมาย x คือทำไม่เสร็จ 

### Using
สิ่งที่นำมาใช้ในตัวงานมีดังนี้
- Database -> PosgreSQL
- Model User, Product, Cart
- จัดทำ API

### API ที่จัดทำมีดังนี้
```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/create/user
```
- เป็น API สำหรับเพิ่ม user โดบ user_id จะถูก gen จาก uuid โดยจะ parameter ที่ต้องกำหนดดังนี้
- header = Content-Type, application/json
- body = name: <yourname>, email: <youremail>, password:<yourpass> <<-- ไม่ได้มีการ hash
    
    
 ```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/product/read-product
```
- เป็น API สำหรับแสดงรายการสินค้าทั้งหมด

- Routes: https://api-add-to-cart-app.herokuapp.com/api/product/add
- เป็น API สำหรับเพิ่มรายการสินค้าลงฐานข้อมูล โดยจะ parameter ที่ต้องกำหนดดังนี้
- header = Content-Type, application/json
- body = product_name: string, price: int , quantity: int

- Routes: https://api-add-to-cart-app.herokuapp.com/api/product/del/{ตรงนี้ใส่เป็น Path query: product_id}
- เป็น API สำหรับลบรายการสินค้าออกจากตารางสินค้า แต่ว่าไม่ได้ลบโดยอ้างอิงจาก id ของผู้ใช้ แต่จะอ้างอิงโดยใช้แค่ product_id เท่านั้น เช่น
- ex: https://api-add-to-cart-app.herokuapp.com/api/product/del/941b9e9d94edd9451d9bbb89d5eb82d431aa  <-- product_id
                                                                                                            
- Routes: https://api-add-to-cart-app.herokuapp.com/api/product/del/read/product/cart/{user_id}
- เป็น API สำหรับเรียกดูรายการสินค้าทั้งหมดที่เรานำใส่ไว้ในตะกร้าสินค้า โดยส่งมาเป็น Path Query : user_id เช่น
- ex: https://api-add-to-cart-app.herokuapp.com/api/product/del/read/product/cart/2ee39a89297cd24653297c824b5026f27875 <-- user_id

- Routes: https://api-add-to-cart-app.herokuapp.com/api/add/product/cart/{product_id}
- เป็น API สำหรับเพิ่มสินค้าลงตระก้าสินค้า โดยข้อกำหนดในการส่งมีดังนี้
- Path Query : product_id
- header = Content-Type, application/json
- body = user_id: string, quantity_product: int, price_product: int


 
