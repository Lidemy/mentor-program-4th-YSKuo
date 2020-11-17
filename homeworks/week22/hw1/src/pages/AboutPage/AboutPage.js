import styled from 'styled-components';

const Content = styled.div`
  display: flex;
  width: 800px;
  margin: 0 auto;
  padding: 40px 0;
`;

const Text = styled.div`
  flex: 2;
  margin-right: 24px;
`;

const Greeting = styled.h1`
  margin: 0;
`;

const Introduction = styled.p``;

const Image = styled.div`
  flex: 1;
  height: 300px;
  background-image: url('https://mcdonalds.com.au/sites/mcdonalds.com.au/files/Product-Details-BigMac-mobile-201904.jpg');
  background-size: cover;
  background-position: center center;
  background-repeat:no-repeat;
`;

export default function AboutPage() {
  return (
    <Content>
      <Text>
        <Greeting>嗨~ 我是 YSKuo.</Greeting>
        <Introduction>
          我是 YSKuo 喜歡「無敵大麥克」，這是用來練習 React Router 及串 API 的作業。
        </Introduction>
      </Text>
      <Image />
    </Content>
  );
}
