import React from 'react';
import {
    AppBar, Button,
    Container,
    IconButton,
    Toolbar, Typography,
} from "@material-ui/core";
import {BrowserRouter, Switch, Route, NavLink} from "react-router-dom";
import Register from "./components/register/Register";
import Login from "./components/login/Login";
import Home from "./components/home/Home";

type NavLinkProps = {
    link: string;
    text: string;
    componentType: 'button' | 'h6';
}

const NavLinkButtonComponent = ({ link, componentType, text }: NavLinkProps) => {
    const sx = {color: 'primary.contrastText'};
    const linkText = componentType === 'button'
        ? <Button sx={sx}>{ text }</Button>
        : <Typography sx={sx} variant={componentType} component="div">{ text }</Typography>;
    return (
        <NavLink to={link} style={{ textDecoration: 'none'}}>
            { linkText }
        </NavLink>
    );
}

function App() {
    return (
        <BrowserRouter>
            <Container>
                <AppBar>
                    <Toolbar>
                        <IconButton edge="start" color="inherit" aria-label="menu">
                            {/*<Menu/>*/}
                        </IconButton>
                        <NavLinkButtonComponent link={'/'} text={'NG'} componentType={'h6'} />
                        <NavLinkButtonComponent link={'/login'} text={'Login'} componentType={'button'} />
                        <NavLinkButtonComponent link={'/register'} text={'Register'} componentType={'button'} />
                    </Toolbar>
                </AppBar>
                <Toolbar />
                <main>
                    <Switch>
                        <Route exact path="/">
                            <Home/>
                        </Route>
                        <Route exact path="/register">
                            <Register/>
                        </Route>
                        <Route exact path="/login">
                            <Login />
                        </Route>
                    </Switch>
                </main>
            </Container>
        </BrowserRouter>
    );
}

export default App;
