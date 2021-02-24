import React from 'react';
import { Switch, Route } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import { TopnavComponent, FooterComponent } from '../components';
import { HomePage } from '../pages';
import { Container } from 'reactstrap';

function App() {
	return (
		<React.Fragment>
			<TopnavComponent />
			<Container>
				<Switch>
					<Route exact path="/" component={HomePage} />
				</Switch>
			</Container>
			<FooterComponent />
		</React.Fragment>
	);
}

export default App;
