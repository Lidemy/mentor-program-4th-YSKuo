import React, { useEffect } from "react";
import { useSelector, useDispatch } from "react-redux";
import { selectTodos } from "./redux/selectors";
import { getTodosFromLocalStorage } from "./redux/actions";
import Header from "./components/Header";
import TodoInput from "./components/TodoInput";
import TodosInfo from "./components/TodoInfo";

function App() {
  const todos = useSelector(selectTodos);
  const dispatch = useDispatch();

  // 把 localStorage 的 todos 拿出來放到 store 裡
  useEffect(() => {
    const todos = JSON.parse(localStorage.getItem("todos"));

    if (todos) {
      dispatch(getTodosFromLocalStorage(todos));
    }
  }, []);

  // 每次 todos 有更新就把 todos 放到 localStorage
  useEffect(() => {
    localStorage.setItem("todos", JSON.stringify(todos));
  }, [todos]);

  return (
    <>
      <Header />
      <TodoInput />
      <TodosInfo />
    </>
  );
}

export default App;
