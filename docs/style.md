# Guia de estilo — Barbearia Antônios

Regras visuais do site. Antes de escrever CSS, confira aqui. Se precisar de algo que não está no guia, combine com a dupla e atualize este arquivo.

---

## 1. Cores

Todas as cores ficam em variáveis no `:root` do `global.css`. **Nunca** escreva um código de cor direto numa regra: use sempre `var(--nome)`.

| Variável | Valor | Uso |
|---|---|---|
| `--cor-fundo` | `#481800` | fundo da página (`body`) e barra do menu |
| `--cor-destaque` | `#f07e13` | títulos, link ativo, bordas, botões |
| `--cor-caixa` | `#444b8a` | fundo dos blocos de conteúdo (cards) |
| `--cor-texto` | `#f5f0e8` | texto comum (creme, contrasta com o fundo e com as caixas) |
| `--cor-erro` | `#ff6b6b` | mensagens e bordas de campo inválido |
| `--cor-sucesso` | `#6bd18a` | borda de campo válido |

**Conflitos resolvidos:** o `#960404` do `login.css` e o `steelblue` do `index.css` saem. Tudo usa a paleta acima.

---

## 2. Tipografia

As duas fontes já vêm instaladas no Windows, então funcionam sem internet.

| Variável | Valor | Uso |
|---|---|---|
| `--fonte-titulo` | `'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif` | `h1`, `h2`, `h3` |
| `--fonte-texto` | `Arial, Helvetica, sans-serif` | todo o resto |

| Elemento | Tamanho |
|---|---|
| `h1` | `2rem` |
| `h2` | `1.5rem` |
| `h3` | `1.2rem` |
| texto | `1rem` |

---

## 3. Espaçamentos

Só três tamanhos, sempre os mesmos:

| Variável | Valor | Uso típico |
|---|---|---|
| `--esp-p` | `8px` | entre itens pequenos (label e campo) |
| `--esp-m` | `16px` | padding de caixas e links do menu |
| `--esp-g` | `32px` | entre seções da página |

---

## 4. Bloco `:root` combinado

Este é o único trecho de código do guia, porque ele **é** a decisão:

```css
:root {
    --cor-fundo: #481800;
    --cor-destaque: #f07e13;
    --cor-caixa: #444b8a;
    --cor-texto: #f5f0e8;
    --cor-erro: #ff6b6b;
    --cor-sucesso: #6bd18a;

    --fonte-titulo: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    --fonte-texto: Arial, Helvetica, sans-serif;

    --esp-p: 8px;
    --esp-m: 16px;
    --esp-g: 32px;
}
```

---

## 5. Componentes (classes reutilizáveis)

Ficam no `global.css`, porque aparecem em mais de uma página.

### Menu — `.menu`
Usado em todas as páginas (gerado pelo `menu.js`).

| Estado | Aparência |
|---|---|
| normal | links lado a lado, centralizados, cor `--cor-texto`, sem sublinhado, sem bolinhas |
| `:hover` | texto muda para `--cor-destaque` |
| `.active` (página atual) | texto `--cor-destaque` + borda inferior de 3px `--cor-destaque` |

A classe `.active` é colocada pelo `menu.js` no link da página aberta.

### Botão — `.btn`
Usado em: "Agendar" (index), "Enviar" (form), "Fazer agendamento" (formAction sem dados).

| Estado | Aparência |
|---|---|
| normal | fundo `--cor-destaque`, texto `--cor-fundo`, sem borda, cantos arredondados (`6px`), padding `--esp-p` `--esp-m` |
| `:hover` | fundo um pouco mais claro e cursor de mãozinha |

Vale para `<button>` e para `<a>` com aparência de botão.

### Caixa — `.card`
Usado em: blocos da index, comprovante, conteúdo do about.

- fundo `--cor-caixa`
- borda `2px solid` `--cor-destaque` (substitui a borda tracejada provisória)
- cantos arredondados `8px`
- padding `--esp-m`

---

## 6. Formulário (fica no `form.css`)

Só existe no `form.html`, então não vai no global.

| Classe / estado | Aparência |
|---|---|
| `.campo` | agrupa label + input + mensagem, com `--esp-p` entre eles |
| input normal | fundo claro, texto escuro, borda `1px` |
| input `:focus` | borda `--cor-destaque` |
| `.invalido` | borda `--cor-erro` |
| `.valido` | borda `--cor-sucesso` |
| `.msg-erro` | texto pequeno, cor `--cor-erro` |

---

## 7. Layout

- Conteúdo de cada página dentro de `<main>`, com **largura máxima de `900px`**, centralizado (`margin: 0 auto`) e padding lateral `--esp-m`.
- O menu ocupa a largura toda da tela.
- **Celular:** os links do menu podem quebrar linha (`flex-wrap: wrap`) em vez de sair da tela.

---

## 8. Organização e nomes

- **`global.css`:** `:root`, `body`, títulos, menu, `.btn`, `.card`, `main`.
- **CSS de cada página:** só o que é exclusivo dela. Nunca redefinir o `body` ou o menu.
- **Ordem no `<head>`:** primeiro `global.css`, depois o da página.
- **Nomes de classes e variáveis:** em português, minúsculas, palavras separadas por hífen (`cor-destaque`, `msg-erro`).
- **Evitar seletores de tag soltos no global** (como `div { }`): eles atingem o site inteiro. Preferir classes.