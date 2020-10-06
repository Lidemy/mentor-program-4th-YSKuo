## 程式碼

```javascript
const obj = {
  value: 1,
  hello: function() {
    console.log(this.value)
  },
  inner: {
    value: 2,
    hello: function() {
      console.log(this.value)
    }
  }
}
  
const obj2 = obj.inner
const hello = obj.inner.hello
obj.inner.hello() // ??
obj2.hello() // ??
hello() // ??
```

---

## 結果

> 要看 this，就看這個函式『怎麽』被呼叫

> 規則就是你在呼叫 function 以前是什麼東西，你就把它放到後面去

按照以上規則，只看呼叫函示前面的東西，並放到 call 裡面，所以
obj.inner.hello() -> obj.inner.hello.call(obj.inner) // 2
obj2.hello() -> obj2.hello.call(obj2) // 2
hello() -> hello.call() // undefined

因此印出結果

##### console
```
2
2
undefined
```
