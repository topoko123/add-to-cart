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

## Using
สิ่งที่นำมาใช้ในตัวงานมีดังนี้
- Database -> PosgreSQL
- Model User, Product, Cart
- จัดทำ API

### API ที่จัดทำมีดังนี้
```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/create/user
```
- เป็น API สำหรับเพิ่ม user โดย user_id จะถูก gen จาก uuid โดยจะ parameter ที่ต้องกำหนดดังนี้
- header = Content-Type, application/json
- method = post
- body = name: <yourname>, email: <youremail>, password:<yourpass> <<-- ไม่ได้มีการ hash

```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/read/all/user
```
- เป็น API สำหรับแสดงข้อมูล user ทั้งหมด โดยสามารถเรียกใช้งานเพื่อดู user_id แล้วนำไปใช้กับ API อื่น ๆ
- method = get
    
 ```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/product/read-product
```
- เป็น API สำหรับแสดงรายการสินค้าทั้งหมด
- method = get

    
```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/product/add
```

- เป็น API สำหรับเพิ่มรายการสินค้าลงฐานข้อมูล โดยจะ parameter ที่ต้องกำหนดดังนี้
- header = Content-Type, application/json
- method = post
- body = product_name: string, price: int , quantity: int

```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/product/del/{product_id}
```
- method = get
- เป็น API สำหรับลบรายการสินค้าออกจากตารางสินค้า แต่ว่าไม่ได้ลบโดยอ้างอิงจาก id ของผู้ใช้ แต่จะอ้างอิงโดยใช้แค่ product_id เท่านั้น เช่น
- ex: https://api-add-to-cart-app.herokuapp.com/api/product/del/941b9e9d94edd9451d9bbb89d5eb82d431aa  <-- product_id
   
```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/product/del/read/product/cart/{user_id}
```
- method = get
- เป็น API สำหรับเรียกดูรายการสินค้าทั้งหมดที่เรานำใส่ไว้ในตะกร้าสินค้า โดยส่งมาเป็น Path Query : user_id เช่น
- ex: https://api-add-to-cart-app.herokuapp.com/api/product/del/read/product/cart/2ee39a89297cd24653297c824b5026f27875 <-- user_id

```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/add/product/cart/{product_id}
```
- เป็น API สำหรับเพิ่มสินค้าลงตระก้าสินค้า โดยข้อกำหนดในการส่งมีดังนี้
- Path Query : product_id
- header = Content-Type, application/json
- method = post
- body = user_id: string, quantity_product: int, price_product: int

```sh
Routes: https://api-add-to-cart-app.herokuapp.com/api/cart/del/{product_id}
```
- เป็น API สำหรับลบสินค้าออกจากตะกร้าสินค้า โดยข้อกำหนดที่ต้องส่งมีดังนี้
- Path Query : product_id
- header = Content-Type, application/json
- method = delete
- body = user_id: string

## สิ่งที่ไม่ได้ใช้
- Authentication & Authorization
- Token
- Middleware
    
 ## โครงสร้างของตาราง
    
 ### users table 

| Field | Type/size | option | description
| ------    | ------      | ------ | ------ |
| id        |  Integer    | PK     | index
| user_id   |  String     | UQ     | รหัสผู้ใช้
| name      |  String     |        | ชื่อเต็ม
| email     | String      | UQ     | อีเมล
| password  | String      |        | รหัสผ่าน

 ### products table 

| Field | Type/size | option | description
| ------    | ------      | ------ | ------ |
| id        |  Integer    | PK     | index
| product_id|  String     | UQ     | รหัสผู้ใช้
| product_name |  String  |        | ชื่อสินค้า
| price     | Integer     |        | ราคา
| quantity  | Integer      |        | จำนวน
 
จากตาราง products จะเห็นได้ว่าไม่ได้ทำ Normalization เพื่อแยกในส่วนของ Cagetory ของสินค้าออกมาอีกตาราง
  
 ### cart table 

| Field | Type/size | option | description
| ------    | ------      | ------ | ------ |
| id        |  Integer    | PK     | index
| user_id   |  String     | FK     | รหัสผู้ใช้->user
| product_id  |  String   | FK     | รหัสสินค้า->products
| quantity_product  | Integer      |        | จำนวนสินค้าในตะกร้า
| price_product | Integer     |        | ราคาสินค้าในตะกร้า
 
จากตาราง cart table จะเป็นตารางที่จะมีการจัดเก็บ user_id -> FK และ product_id -> FK เพื่อใช้อ้างอิงถึงข้อมูลของตารางอื่น ๆ
    
## ข้อแนะนำการใช้งาน
- ให้ทำการเรียกใช้งาน API ในการสร้าง user
- ทำการเรียกใช้งาน API ในการสร้าง product
- ลองเรียกใช้งาน API สำหรับแสดง user ทั้งหมด และคัดลอก user_id ไว้
- ลองเรียกใช้งาน API สำหรับแสดงรายการสินค้าทั้งหมดจากตาราง products และคัดลอก product_id ไว้
- เรียกใช้งาน API สำหรับเพิ่มสินค้าลงตะกร้า โดยนำ product_id ใส่ไว้ที่ Path Query และ user_id อยู่ใน body สามารถดูเพิ่มเติมจากด้านบนได้
- ลองเรียกใช้งาน API สำหรับแสดงรายการสินค้าในตะกร้า เฉพาะบุคคล โดยส่ง product_id ไว้ในส่วน Path Query และ user_id อยู่ใน body สามารถดูเพิ่มเติมจากด้านบนได้
- สามารถลองเรียกใช้งาน API สำหรับลบรายการสินค้าออกจากตะกร้าสินค้า เฉพาะบุคคล โดยส่ง product_id ไว้ในส่วน Path Query และ user_id อยู่ใน body สามารถดูเพิ่มเติมจากด้านบนได้
    
## Deployment
deployment on heroku: https://api-add-to-cart-app.herokuapp.com/
