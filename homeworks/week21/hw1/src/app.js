import React, { Component } from "react";
import Header from "./components/Header";
import TodoInput from "./components/TodoInput";
import TodosInfo from "./components/TodosInfo";
import "normalize.css";
import "../styles/styles.scss";

export default class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      localTodos: [],
      filter: "all",
      content: "",
    };
  }

  componentDidMount() {
    console.log("componentDidMount", this.state);
    try {
      // mount 完就把 localStorage 的 localTodos 拿出來並 setState
      const json = localStorage.getItem("localTodos");
      const localTodos = JSON.parse(json);
      if (localTodos) {
        this.setState({ localTodos });
      }
    } catch (e) {
      // 發生錯誤就什麼都不做
    }
  }

  componentDidUpdate() {
    console.log("componentDidUpdate", this.state);
    // 每次有 update 就把 localTodos 放到 localStorage
    const json = JSON.stringify(this.state.localTodos);
    localStorage.setItem("localTodos", json);
  }

  handleInputOnChange = (e) => {
    this.setState({ content: e.target.value });
  };

  handleAddTodo = (e) => {
    e.preventDefault();
    const content = this.state.content.trim();

    // input 有內容的話就 setState
    if (content) {
      const todo = {
        id: Date.now(),
        content,
        isCompleted: false,
      };
      this.setState({
        localTodos: [todo, ...this.state.localTodos],
      });
    }
    // 新增 todo 到 state 完，再把 content 清空
    this.setState({ content: "" });
  };

  handleClearCompletedTodos = () => {
    // 用 filter 留下所有標記未完成的
    this.setState((prevState) => ({
      localTodos: prevState.localTodos.filter((todo) => !todo.isCompleted),
    }));
  };

  handleClearTodo = (id) => {
    // 用 filter 留下和要刪除的 todoId 不符合的 todo 們
    this.setState((prevState) => ({
      localTodos: prevState.localTodos.filter(
        (todo) => todo.id !== parseInt(id, 10)
      ),
    }));
  };

  handleCheckboxChange = (id) => {
    this.setState((prevState) => ({
      localTodos: prevState.localTodos.map((todo) => {
        // 如果 id 吻合就改變 isCompleted 狀態
        if (todo.id === parseInt(id, 10)) {
          return {
            ...todo,
            isCompleted: !todo.isCompleted,
          };
        }
        // id 不吻合就不改變直接回傳
        return todo;
      }),
    }));
  };

  handleCompleteAllToggle = () => {
    // 如果 localTodos 的 todo 數目和標記 completed 的 todo 數目一樣
    // 就把所有的 todo 標記未完成，反之就把所有的 todo 標記完成

    const allCompleted = this.state.localTodos.every(
      (todo) => todo.isCompleted
    );
    this.setState((prevState) => ({
      localTodos: prevState.localTodos.map((todo) => ({
        ...todo,
        isCompleted: !allCompleted,
      })),
    }));
  };

  handdlePickFilter = (e) => {
    e.preventDefault();
    const value = e.target.value;
    this.setState({ filter: value });
  };

  handleEditTodo = (e) => {
    const todoId = parseInt(e.target.id, 10);
    const content = e.target.value;
    this.setState((prevState) => ({
      localTodos: prevState.localTodos.map((todo) => {
        // id 吻合就放上新的 content
        if (todo.id === todoId) {
          return {
            ...todo,
            content: content,
          };
        }
        // id 不吻合就不進行改變直接回傳
        return todo;
      }),
    }));
  };

  render() {
    const { localTodos, filter, content } = this.state;
    return (
      <>
        <Header />
        <TodoInput
          content={content}
          handleInputOnChange={this.handleInputOnChange}
          handleAddTodo={this.handleAddTodo}
        />
        <TodosInfo
          localTodos={localTodos}
          filter={filter}
          handleCheckboxChange={this.handleCheckboxChange}
          handleClearCompletedTodos={this.handleClearCompletedTodos}
          handleClearTodo={this.handleClearTodo}
          handdlePickFilter={this.handdlePickFilter}
          handleCompleteAllToggle={this.handleCompleteAllToggle}
          handleEditTodo={this.handleEditTodo}
        />
      </>
    );
  }
}
