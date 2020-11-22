import styled from "styled-components";

const Footer = styled.footer`
  .desc {
    padding: 26px 0;
    text-align-last: center;
    background-color: black;
    color: #999999;
    font-size: 13px;
  }
`;

export default () => (
  <Footer>
    <div className="desc">
      © 2020 © Copyright. All rights Reserved.
    </div>
  </Footer>
);
