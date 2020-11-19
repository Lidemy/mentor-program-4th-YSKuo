import styled from "styled-components";

const Header = styled.section`
  & .form__desc {
    margin-top: 35px;
    line-height: 1.5em;
  }

  & p {
    font-size: 16px;
    margin-top: 22px;
  }

  & .form__note {
    color: #e74149;
  }
`;

export default () => (
  <Header>
    <h1 className="form__title">新拖延運動報名表單</h1>
    <p className="form__desc">活動日期：2020/12/10 ~ 2020/12/11<br/>活動地點：台北市大安區新生南路二段1號</p>
    <p className="form__note">*必填</p>
  </Header> 
);