<?php
/**
 * Created by PhpStorm.
 * User: levsemin
 * Date: 11.04.15
 * Time: 20:02
 */

namespace Slev\LtreeExtensionBundle\DqlFunction;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class LtreeOperatorFunction extends FunctionNode
{
    protected $operator;
    protected $first;
    protected $second;

    /**
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return sprintf("(%s %s %s)",
            $this->first->dispatch($sqlWalker),
            $this->operator->value,
            $this->second->dispatch($sqlWalker)
        );
    }

    /**
     * @param Parser $parser
     *
     * @return void
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->first = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->operator = $parser->StringExpression();
        $parser->match(Lexer::T_COMMA);
        $this->second = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}