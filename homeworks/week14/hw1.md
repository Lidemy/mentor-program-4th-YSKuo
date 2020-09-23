看完 [CS75 (Summer 2012) Lecture 9 Scalability Harvard Web Development David Malan](https://www.youtube.com/watch?v=-W9F__D3oY4) 還是有很多不太懂，於是又估狗了一下縮網址的資訊，找到了這個 [Designing a URL Shortening service like TinyURL](https://www.educative.io/courses/grokking-the-system-design-interview/m2ygV4E81AR?aid=5082902844932096&utm_source=google&utm_medium=cpc&utm_campaign=grokking-manual&gclid=CjwKCAjw2Jb7BRBHEiwAXTR4jYluBJoxoqX7Bfd3-JCET0LWThMAm3xoQdoWi5ECTCy3g_GJ1o2OYBoCBEYQAvD_BwE)，所以這個作業基本上按照這份的內容去畫的。

畫的圖 
![](https://i.imgur.com/WEe3t1z.png)

按我的理解寫一遍 client 透過短網址轉址的流程

1. 由 load balancer 分配 request 給 server
  - 疑問：load balancer 應該要有好幾個 backup，以免只有一個卻壞掉而無法分配？
2. 由 server 處理 request，在這階段可判斷短碼是否符合規則
  - 若不符合短碼規則，則直接回傳錯誤給 client（例：找不到相應的 URL，請再確認）
  - 如果符合規則才進入下一步
3. server 要找 original URL，由 load balancer 分配 loading 給 cache
  - 疑問：cache 應該也要有好幾個來分擔 loading？
4. 近期被訪問過的 短碼 <-> original URL 會被存在 cache 中
  - 在 cache 裡面找到 original URL 就回傳給 server，server 再回傳 response 給 client（透過 redirect 帶到 original URL）
  - 若沒找到 original URL 則到 database 找
5. 透過 load balancer 分配 loading 給 database
6. database 找 original URL
  - 找到則回傳給 server，並更新該筆資料到 cache
  - 若沒有找到則回傳錯誤給 client